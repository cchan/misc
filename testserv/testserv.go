package main

import (
  "net"
  "log"
)

func main() {
  ln, err := net.Listen("tcp", ":8848")
  if err != nil {
    log.Fatal(err)
  }
  log.Println("Listening on :8848")
  for {
    conn, err := ln.Accept()
    if err != nil {
      log.Fatal(err)
    }
    go func(c net.Conn) {
      c.Write([]byte("HTTP/1.1 200 OK\r\nContent-Length: 386\r\n\r\n<style>body{background-color:#FCF0E4;font-family:Arial;text-align:center;padding-top:4em;color:#462201;}footer{position:fixed;bottom:0;left:0;right:0;text-align:center;opacity:0.2;padding-bottom:2em;}</style><h1>i'm a little server</h1><img src='http://cdn0.dailydot.com/uploaded/images/original/2014/8/18/pusheen.gif'><footer><a href='https://clive.io'>clive</a>'s test server</footer>"))
    }(conn)
  }
}
