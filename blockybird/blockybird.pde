void setup(){
  size(400,300);
  frameRate(30);
  r();
}
void r(){c=(400-(n=-2)*(floor(y=100+(d=0))/5+(x=h[0]=h[1]=h[2]=0)))/3;}
float y,d;
int l,x,n,c,i,m;
int[] h=new int[3];
void draw(){
  clear();
  for(fill(253+(i=2));i>=0;rect(x+i*c,0,40,h[i--]))
    if(i<2&&(h[i]!=0&&(x+c*(i-1)>-40&&x+c*(i-1)<15)&&(y<h[i]||y>h[i]+85)||i*285<y*(2*i-1)))r();
    else if(h[i]!=0)rect(x+i*c,h[i]+100,40,200-h[i]);
  rect(floor(c),floor(y+=(d+=0.7)),15,15);
  fill(0,255,0);
  textSize(30);
  text((n<0?0:n),150,150);
  textSize(15);
  text("best: "+m,150,180);
  if((x-=3+abs(n/10))<=-40){
    m=++n>m?n:m;
    x+=c;
    h[0]=h[1];
    h[1]=h[2];
    h[2]=floor(random(30,170));
  }
}
void mousePressed(){
  d=-10;
}
void keyPressed(){
  d=-10;
}
