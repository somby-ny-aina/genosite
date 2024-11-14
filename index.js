const express = require('express');
const axios = require('axios');
const fs = require('fs');
const path = require('path');
const { renderToString } = require('katex');
const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.get('/convert-webp-to-jpg', async (req, res) => {
  const { imageUrl } = req.query;

  if (!imageUrl) {
    return res.status(400).send('❌ Please provide an image URL');
  }

  try {
    const response = await axios.get(imageUrl, { responseType: 'arraybuffer' });
    const outputFilePath = path.join(__dirname, 'output.jpg');
    
    fs.writeFile(outputFilePath, response.data, (err) => {
      if (err) {
        console.error('Error saving image:', err);
        return res.status(500).send('❌ Error saving image');
      }

      console.log('Image saved successfully');
      res.status(200).sendFile(outputFilePath);
    });
  } catch (error) {
    console.error('Error downloading the image:', error.message);
    return res.status(500).send('❌ Error downloading the image');
  }
});

app.post('/convert-latex', (req, res) => {
  try {
    const inputText = req.body.text;

    const outputText = inputText.replace(/\\(.*?)\\/g, (match, latexExpr) => {
      return renderToString(latexExpr, { throwOnError: false });
    });

    res.status(200).send({ output: outputText });
  } catch (error) {
    res.status(500).send({ error: 'Error processing LaTeX text.' });
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
