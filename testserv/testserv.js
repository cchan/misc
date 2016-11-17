require('http').createServer((req,res)=>res.end(`
<style>
  body{
    background-color:#FCF0E4;
    font-family:'Open Sans',Arial,sans-serif;
    text-align:center;
    padding-top:4em;
    color:#462201;
  }
</style>
<h1>i'm a little server</h1>
<img src='http://cdn0.dailydot.com/uploaded/images/original/2014/8/18/pusheen.gif'>
`)).listen(8848,()=>console.log('listen 8848'));
