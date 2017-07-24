// Compiles with gcc (Ubuntu 4.8.4-2ubuntu1~14.04.3) 4.8.4 on Windows Linux Subsystem

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/types.h> 
#include <sys/socket.h>
#include <netinet/in.h>

// todo next: remove the sleep(), add pthread, better error & TCP-signal handling,
//    generalize this to express-like simplicity of routes

void error(const char *msg)
{
    printf("ERROR %s\n", msg);
    exit(1);
}

int main(int argc, char *argv[])
{
  int sockfd, newsockfd, portno, webpagefd;
  socklen_t clilen;
  char buffer[256],
    webpage[] = "HTTP/1.1 200 OK\r\nContent-Length: 344\r\n\r\n<style>body{background-color:#FCF0E4;font-family:Arial;text-align:center;padding-top:4em;color:#462201;}footer{position:fixed;bottom:0;left:0;right:0;text-align:center;opacity:0.2;padding-bottom:2em;}</style><h1>i'm a little server</h1><img src='https://clive.io/testserv.gif'><footer><a href='https://clive.io'>clive</a>'s test server</footer>",
    errpage[] = "HTTP/1.1 404 Not Found\r\nContent-Length: 521\r\n\r\n<style>html,body{height:100%;background-color:#FCF0E4;font-family:Arial,sans-serif;text-align:center;color:#462201;font-size:1.1em;margin:0;}img{height:60%;}a{font-weight:bold;color:#8c4402}footer{position:absolute;font-size:0.7em;bottom:0.5em;width:100%;text-align:center;opacity:0.5;}</style><h1><img src='https://clive.io/img/404.gif' alt='glitched.'/></h1><p><b>404 Not Found!</b> This isn't the cat you're looking for.</p><p><a href='/'>Go home?</a></p><footer><a href='https://clive.io'>clive</a>'s website</footer>";
  int webpagelen = strlen(webpage), errpagelen = strlen(errpage);
  struct sockaddr_in serv_addr, cli_addr;
  char *PORT_str;
  
  //printf("%s\n", PORT_str);
  
  printf("%s\n", getenv("PORT"));
  
  if((PORT_str = getenv("PORT")) == NULL)
    error("no $PORT provided");
  if ((portno = atoi(PORT_str)) <= 0 || portno > 65535)
    error("invalid port");
  
  if ((sockfd = socket(AF_INET, SOCK_STREAM, 0)) < 0)
    error("opening socket");
  
  bzero((char *) &serv_addr, sizeof(serv_addr));
  serv_addr.sin_family = AF_INET;
  serv_addr.sin_port = htons(portno);
  serv_addr.sin_addr.s_addr = INADDR_ANY;
  if (bind(sockfd, (struct sockaddr *) &serv_addr, sizeof(serv_addr)) < 0)
    error("binding");
  listen(sockfd, 5);
  
  //bzero(webpage, 512);
  //if ((webpagefd = open("httpresponse.txt")) < 0)
  //  error("getting webpage file");
  //read(webpagefd, webpage, 511);
  
  printf("Listening on port %d\n", portno);
  
  while(1){
    clilen = sizeof(cli_addr);
    if ((newsockfd = accept(sockfd, (struct sockaddr *) &cli_addr, &clilen)) < 0) 
      error("on accept");
    
    /*
    if (write(newsockfd, webpage, webpagelen) < 0)
      error("writing to socket");
    */
    bzero(buffer, 256);
    if (read(newsockfd, buffer, 255) < 0)
      error("reading from socket");
    //printf("Got stuff %s\n", buffer);
    if (strncmp("GET / HTTP", buffer, 10) == 0){
      if (write(newsockfd, webpage, webpagelen) < 0)
        error("writing to socket");
    }else{
      if (write(newsockfd, errpage, errpagelen) < 0)
        error("writing to socket");
    }
    sleep(1); // http://blog.csdn.net/CPP_CHEN/article/details/29864509
    close(newsockfd);
  }
  close(sockfd);
  return 0; 
}