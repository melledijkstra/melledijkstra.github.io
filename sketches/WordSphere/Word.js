/**
 * Created by melle on 17-6-2017.
 * I know prototyping exists, this is just a little easier
 */
var Word = function(t, ts) {
    this.t = t;
    this.size = ts;
    this.x = random(0,width);
    this.y = random(0,height);

    this.update = function() {
        this.x += this.size * 0.2;
        this.bounds();
    };

    this.draw = function() {
        textSize(this.size);
        text(this.t, this.x, this.y);
    };

    this.bounds = function() {
        if(this.x > width) {
            this.x = -100;
        }
    }
};