FROM node:alpine

WORKDIR /app
COPY ./nest /app

RUN npm install
RUN npm run build

CMD ["node", "dist/main"]