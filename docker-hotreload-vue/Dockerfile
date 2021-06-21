# base image
FROM meesk/node-cqc:10.15.0.3
 
# set working directory
RUN mkdir /usr/src/app
WORKDIR /usr/src/app
 
# add `/usr/src/app/node_modules/.bin` to $PATH
ENV PATH /usr/src/app/node_modules/.bin:$PATH
 
# install and cache app dependencies
COPY package.json /usr/src/app/package.json
COPY .env.development /usr/src/app/.env.development
COPY .env.production /usr/src/app/.env.production
RUN npm install --no-audit
COPY . /usr/src/app/
