FROM node:alpine

WORKDIR /app
COPY ./src /app

RUN npm install
RUN npm run build

CMD ["node", "index.js"]