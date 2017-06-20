var r = 150;
var angle = 0;
// flag to check if angle should increment or use the angleSlider's value
var shouldIncrement = true;

var rSlider, angleIncSlider, angleSlider;

function setup() {
    createCanvas(window.innerWidth, window.innerHeight);
    // creating sliders to change variables
    rSlider = createSlider(1, 255, r);
    rSlider.position(20, height - 50);
    // slider for the value to increament angle by
    angleIncSlider = createSlider(0, 5, 1, 0.1);
    angleIncSlider.position(20, rSlider.y - 20);
    angleIncSlider.mousePressed(function () {
        shouldIncrement = true;
    });
    // slider to specify angle directly
    angleSlider = createSlider(0, 360, angle, 1);
    angleSlider.position(20, angleIncSlider.y - 20);
    angleSlider.mousePressed(function () {
        shouldIncrement = false;
    });
    textSize(14);
    // this sketch will use DEGREES instead of RADIANS
    angleMode(DEGREES);
}

function draw() {
    background(0);
    // draw from the center of the screen
    translate(width / 2, height / 2);
    // retrieve the radius what our circle should be
    r = rSlider.value();

    fill(100);
    ellipse(0, 0, r * 2, r * 2); // diameter of circle = radius * 2

    // first calculate the cos and sin of angle
    /*
     * I store this value so I don't need to
     * calculate it again when printing on the screen, saves a few calculations :)
     */
    var acos = cos(angle);
    var asin = sin(angle);
    // calculate the x and y values from our current angle
    var x = r * acos;
    var y = r * asin;
    // draw a small circle at the calculated point (size = 1/15 of the big circle)
    fill(255, 0, 0, 200);
    ellipse(x, y, r / 15, r / 15);

    // draw the triangle
    stroke(255, 100);
    // line from center to calculated point, this stays the hypotenuse independed of the current angle
    line(0, 0, x, y);
    // this is the straight line which stays fixed on the x axis, only it's calculated y value moves
    line(0, 0, 0, y);
    // last line to connect the 2
    line(0, y, x, y);

    // the angle changes based on which slider is used last
    if (shouldIncrement) {
        angle += angleIncSlider.value();
    } else {
        angle = angleSlider.value();
    }

    // draw all the numbers and labels for sliders
    noStroke();
    fill(255);
    var tx = 10 - width / 2; // text x position. Because sketch is translated the top left need to recalculate
    var ty = height / 2; // text y position
    text('angle: ' + nf(angle, 0, 2), tx, 20 - ty);
    text('x,y: ' + nf(x, 0, 2) + ' | ' + nf(y, 0, 2), tx, 35 - ty);
    text('cos(angle): ' + nf(acos, 0, 2), tx, 50 - ty);
    text('cos(angle): ' + nf(asin, 0, 2), tx, 65 - ty);
    text('radius: ' + r, tx, 80 - ty);
    // slider labels
    text('Radius slider', tx + rSlider.x + rSlider.width + 20, -ty + rSlider.y + textSize());
    text('Incremental slider', tx + angleIncSlider.x + angleIncSlider.width + 20, -ty + angleIncSlider.y + textSize());
    text('Angle slider', tx + angleSlider.x + angleSlider.width + 20, -ty + angleSlider.y + textSize());

    // reset the angle when it's above 360 degrees. The calculated values would stay the same, but just for correctness
    if (angle > 360) angle = 0;
}
