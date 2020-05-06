let video;
let poseNet;
let noseX = 0;
let noseY = 0;
let eyelX = 0;
let eyelY = 0;
let eyeRX = 0;
let eyeRY = 0;
let Nscore =0;
let Wrscore =0;
let LeftWrX =0;
let LeftWrY=0;
var butter,ramadan,slayer,mask,daft,punk,bmo;

var helmet;
 function preload(){
  
  //ramadan = createImg("ram.png");
  //slayer = createImg("red.gif");
  mask = createImg("http://localhost/taland/web/uploads/posts/mask.gif");
  daft = createImg("http://localhost/taland/web/uploads/posts/daft.gif");
  punk = createImg("http://localhost/taland/web/uploads/posts/daft_led.gif");
  //bmo = createImg("bmo.gif");
  butter = createImg("http://localhost/taland/web/uploads/posts/butter.gif");
 }

function setup() {
  var canvas = createCanvas(600, 370);
  canvas.parent('sketch-holder');
  angleMode(DEGREES);
  video = createCapture(VIDEO);
  video.hide();
  poseNet = ml5.poseNet(video, modelReady);
  poseNet.on('pose', gotPoses);

  mask.hide()
  daft.hide()
  punk.hide()


  
}

function gotPoses(poses) {
  // console.log(poses);
  if (poses.length > 0) {
    let nX = poses[0].pose.keypoints[0].position.x;
    let nY = poses[0].pose.keypoints[0].position.y;
    Nscore = poses[0].pose.keypoints[0].score;

    let leX = poses[0].pose.keypoints[1].position.x;
    let leY = poses[0].pose.keypoints[1].position.y;
    let reX = poses[0].pose.keypoints[2].position.x;
    let reY = poses[0].pose.keypoints[2].position.y;

    LeftWrX = poses[0].pose.keypoints[5].position.x;
    LeftWrY = poses[0].pose.keypoints[5].position.y;
    Wrscore = poses[0].pose.keypoints[5].score;

    noseX = lerp(noseX, nX, 0.9);
    noseY = lerp(noseY, nY, 0.9);

    eyelX = lerp(eyelX, leX, 0.9);
    eyelY = lerp(eyelY, leY, 0.9);
    
    eyeRX = lerp(eyeRX, reX, 0.9);
    eyeRY = lerp(eyeRY, reY, 0.9);

    
  }
}

function modelReady() {
  console.log('model ready');
}

function draw() {

  image(video, 0, 0);
  let d = dist(noseX, noseY, eyelX, eyelY);

  //fill(255, 0, 0);
  //ellipse(noseX, noseY, d);

  //image(gif_createImg,noseX-(d/2),noseY-(d/2),d,d);

  //if (Nscore>0.5) {
  //butter.show();  
  butter.size(d,d);
  butter.position(noseX-(d/2)+10,noseY-(d/2)-5);       
  /*}else{
    butter.hide();
  }*/

  //slayer.position(eyeRX-(d/2)-20,eyeRY-(d/2)-90);
  //slayer.size(d+Math.abs(eyelX - eyeRX)+40,d+180);

  mask.position(eyeRX-(d/2)-60,eyeRY-(d/2)-60);
  mask.size(d+200,d+230);
//
  daft.position(noseX-(d/2)-190,noseY-(d/2)-220);
  daft.size(d+350,d+400);

  punk.position(noseX-(d/2)-245,noseY-(d/2)-365);
  punk.size(d+460,d+600);

  /*if (Wrscore>0.5) {
  bmo.show();  
  bmo.position(LeftWrX-100,LeftWrY-200);  
  bmo.size(d+100,d+100);
  }else{
    bmo.hide();
  }*/
  

  
  //ramadan.position(510,10);
  //ramadan.size(120,270);
  //fill(0,0,255);
  //ellipse(eyelX, eyelY, 50);

}
function showbutter(){

  butter.show();
  mask.hide();
  daft.hide();
  punk.hide();
}
function showdaft(){

  daft.show();
  mask.hide();
  butter.hide();
  punk.hide();
}
function showpunk(){

  punk.show();
  mask.hide();
  daft.hide();
  butter.hide();
}
function showcorona(){

  mask.show();
  butter.hide();
  daft.hide();
  punk.hide();
}


