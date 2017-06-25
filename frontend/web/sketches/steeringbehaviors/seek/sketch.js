/**
 * Steering Behaviour created by Melle Dijkstra
 */

var particle;

function windowResized() {
    resizeCanvas(window.innerWidth, window.innerHeight);
}

function setup() {
    createCanvas(window.innerWidth, window.innerHeight);
    frameRate(1);
    particle = new Particle(createVector(width/2, height/2));
    noStroke();
}

function draw() {
    background(200);
    particle.update();
    particle.draw();
}
