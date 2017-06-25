/**
 * Created by melle on 22-6-2017.
 */

var Particle = function(position) {
    this.pos = position;
    this.vel = createVector(0,0);
    this.size = 50;

    this.update = function() {
        this.vel = createVector(random(-5,5), random(random(-5,5)));
        this.pos.add(this.vel);
    };

    this.draw = function() {
        // draw the Particle
        fill(255,0,0);
        rect(this.pos.x,this.pos.y, this.size, this.size);
        stroke(0,255,0);
        this.vel.setMag(100);
        line(this.pos.x,this.pos.y,this.pos.x + this.vel.x,this.pos.y + this.vel.y);
        noStroke();
        fill(0);
        text('P('+round(this.pos.x)+','+round(this.pos.y)+')', this.pos.x, this.pos.y + this.size + textSize());
        text('V('+round(this.vel.x)+','+round(this.vel.y)+')', this.pos.x + this.vel.x, this.pos.y + this.vel.y);
    };
};
