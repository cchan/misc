require('http').createServer((req,res)=>{
  res.setHeader('Content-Type', 'text/html');
  res.end(`
<style>
  body{
    background-color:#FCF0E4;
    font-family:'Open Sans',Arial,sans-serif;
    text-align:center;
    padding-top:4em;
    color:#462201;
  }
  footer{
    position:fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    opacity: 0.2;
    padding-bottom: 2em;
  }
</style>
<h1>i'm a little server</h1>
<img src='https://clive.io/testserv.gif'>
<footer><a href="https://clive.io">clive</a>'s test server</footer>`);
}).listen(8848,()=>console.log('listen 8848'));
