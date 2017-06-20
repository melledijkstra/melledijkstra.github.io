/**
 * Word Sphere created by Melle Dijkstra
 */
var r = 150;
var angle = 0;

var wordList = ['Philosophy', 'Science', 'Hiking', 'Reading', 'Programming', 'Mountains', 'Study', 'Talk', 'Wild Camping',
    'Autodidact', 'Visualization'];

// The actual list with Word objectsab
var words = [];
var points = [];

function windowResized() {
    resizeCanvas(window.innerWidth, window.innerHeight);
}

function setup() {
    createCanvas(window.innerWidth, window.innerHeight);
    background(0);

    fill(255);

    wordList.forEach(function (word) {
        words.push(new Word(word, random(10,25)));
    });

    for(var i = 0; i< 500; i++) {
        points.push(createVector(random(0,width),random(0,height)));
    }
}

function draw() {
    background(0);
    words.forEach(function (word) {
        word.update();
        word.draw();
    });
    points.forEach(function (point) {
        point.x += random(-1,1);
        point.y += random(-1,1);
        ellipse(point.x,point.y,2);
    })
}
