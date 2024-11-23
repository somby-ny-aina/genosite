const express = require('express');
const sharp = require('sharp');
const fs = require('fs');
const path = require('path');
const app = express();
const port = 3000;

app.get('/convert-webp-to-jpg', async (req, res) => {
  const { imageUrl } = req.query;

  if (!imageUrl) {
    return res.status(400).send('❌ Please provide an image URL');
  }

  try {
    const response = await axios.get(imageUrl, { responseType: 'arraybuffer' });

    const outputFilePath = path.join(__dirname, 'output.jpg');
    
    sharp(response.data)
      .toFormat('jpeg')
      .toFile(outputFilePath, (err, info) => {
        if (err) {
          console.error('Error converting image:', err);
          return res.status(500).send('❌ Error converting image');
        }

        console.log('Image converted successfully:', info);
        res.status(200).sendFile(outputFilePath);
      });
  } catch (error) {
    console.error('Error downloading the image:', error.message);
    return res.status(500).send('❌ Error downloading the image');
  }
});

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
});

app.use(bodyParser.json());

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
