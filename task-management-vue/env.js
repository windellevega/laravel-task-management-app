var env = {
    ENVIRONMENT: process.env.ENVIRONMENT,
    API_HOST: 'http://localhost:8000/'
  }
  
  if (process.env.ENVIRONMENT === 'testing') {
    env.TEST_API = `http://localhost:${process.env.PORT}`
  }
  
  module.exports = env