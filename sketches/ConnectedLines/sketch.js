/**
 * Connected Lines created by Melle Dijkstra
 */

var points = [];

function windowResized() {
    resizeCanvas(window.innerWidth, window.innerHeight);
}

function setup() {
    createCanvas(window.innerWidth, window.innerHeight);
    background(0, 0, 0);

    fill(255);
    noStroke();

    for (var i = 0; i < 15; i++) {
        var point = new Point(createVector(random(0, width), random(0, height)));
        point.generatePoints(5);
        points.push(point);
    }
}

function draw() {
    points.forEach(function (point) {
        point.draw();
    });

    noLoop();
}
