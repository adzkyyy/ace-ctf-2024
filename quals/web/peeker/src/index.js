const express = require('express');
const axios = require('axios');
const path = require('path');

const app = express();
const port = 3000;

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(express.static(path.join(__dirname, 'public')));

app.get('/', async (req, res) => {
    res.render('index');
});

app.get('/proxy', async (req, res) => {
    const username = req.query.url;

    if (!username) {
        res.status(400).send('Missing url parameter');
        return;
    }

    try {
        const github = axios.create({
            baseURL: 'https://github.com',
        });
        const response = await github.get(`/${username}`);
        app.locals.fetchedContent = response.data;
        if (response.status === 200) {
            res.render('result');
        } else {
            res.render('error');
        }
    } catch (error) {
        res.status(500).send(error.message);
    }
});

app.get('/result', (req, res) => {
    res.send(app.locals.fetchedContent || 'No content available');
});

app.get('/admin', (req, res) => {
    console.log(req.ip);
    if (req.ip === '127.0.0.1') {
        res.render('admin', { content: process.env.FLAG });
    } else {
        res.status(403).send('Forbidden');
    }
});

app.listen(port, () => {
    console.log(`Server running on port ${port}`);
})