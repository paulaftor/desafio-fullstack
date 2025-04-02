FROM node:18

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install -g @vue/cli && npm install --legacy-peer-deps

COPY . .

RUN chmod -R 777 /app

EXPOSE 8080

CMD ["npm", "run", "serve"]
