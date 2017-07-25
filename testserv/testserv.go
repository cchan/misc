package main

import (
  "net"
  "log"
  "os"
)

func main() {
  port := os.Getenv("PORT")
  if port == "" { log.Fatal("Need a $PORT number!") }
  ln, err := net.Listen("tcp", ":" + port)
  if err != nil { log.Fatal(err) }
  log.Println("Listening on :" + port)
  for {
    conn, err := ln.Accept()
    if err != nil { log.Fatal(err) }
    go func(c net.Conn) {
      buffer := make([]byte, 10)
      n, err := conn.Read(buffer)
      if err != nil { log.Fatal(err) }
      if n == 10 && "GET / HTTP" == string(buffer) {
        c.Write([]byte("HTTP/1.1 200 OK\r\nContent-Length: 344\r\n\r\n<style>body{background-color:#FCF0E4;font-family:Arial;text-align:center;padding-top:4em;color:#462201;}footer{position:fixed;bottom:0;left:0;right:0;text-align:center;opacity:0.2;padding-bottom:2em;}</style><h1>i'm a little server</h1><img src='https://clive.io/testserv.gif'><footer><a href='https://clive.io'>clive</a>'s test server</footer>"))
      } else {
        c.Write([]byte("HTTP/1.1 404 Not Found\r\nContent-Length: 521\r\n\r\n<style>html,body{height:100%;background-color:#FCF0E4;font-family:Arial,sans-serif;text-align:center;color:#462201;font-size:1.1em;margin:0;}img{height:60%;}a{font-weight:bold;color:#8c4402}footer{position:absolute;font-size:0.7em;bottom:0.5em;width:100%;text-align:center;opacity:0.5;}</style><h1><img src='https://clive.io/img/404.gif' alt='glitched.'/></h1><p><b>404 Not Found!</b> This isn't the cat you're looking for.</p><p><a href='/'>Go home?</a></p><footer><a href='https://clive.io'>clive</a>'s website</footer>"))
      }
    }(conn)
  }
}
