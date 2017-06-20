/**
 * Created by melle on 17-6-2017.
 */
var Point = function (position) {

    this.pos = position;
    // 10% if this is bigCircle
    this.bigCircle = random(0, 10) < 1;
    // a point can have references to other points
    this.points = [];
    this.alpha = random(5, 255);
    // random radius for this point
    this.r = random(3, 10);
    this.distance = width / 10;

    this.generatePoints = function (amount) {
        ++Point.generation;
        for (var i = 0; i < amount; i++) {
            var point = new Point(createVector(this.pos.x + random(-this.distance, this.distance), this.pos.y + random(-this.distance, this.distance)));
            if (Point.generation < 20) {
                point.generatePoints(5);
            }
            this.points.push(point);
        }
        return this.points.length;
    };

    this.draw = function () {
        if (this.bigCircle) {
            fill(232, 123, 90, 100);
            ellipse(this.pos.x, this.pos.y, 20);
        }
        fill(232, 123, 90);
        ellipse(this.pos.x, this.pos.y, this.r);
        var _this = this;
        this.points.forEach(function (point) {
            stroke(232, 123, 90, point.alpha);
            // draw a line between this point and the connected point
            line(_this.pos.x, _this.pos.y, point.pos.x, point.pos.y);
            noStroke();
            point.draw();
        })
    };

};

Point.generation = 0;
