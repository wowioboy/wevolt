var NS4 = (document.layers) ? 1 : 0;
var IE4 = (document.all) ? 1 : 0;

function animation(id) {
  this.element = (NS4) ? document[id] : document.all[id].style;
  this.active = 0;
  this.timer = null;
  this.path = null;
  this.num = null;

  this.name = id + "Var";
  eval(this.name + " = this");

  this.animate = animate;
  this.step = step;
  this.show = show;
  this.hide = hide;
  this.left = left;
  this.top = top;
  this.moveTo = moveTo;
  this.slideBy = slideBy;
  this.slideTo = slideTo;
  this.circle = circle;
}

function pos(x, y) {
  this.x = Math.round(x);
  this.y = Math.round(y);
}

function show() {
  this.element.visibility = (NS4) ? "show" : "visible";
}

function hide() {
  this.element.visibility = (NS4) ? "hide" : "hidden";
}

function left() {
  return parseInt(this.element.left);
}

function top() {
  return parseInt(this.element.top);
}

function moveTo(x, y) {
  this.element.left = x;
  this.element.top = y;
}

function step() {
  this.moveTo(this.path[this.num].x, this.path[this.num].y);
  if (this.num >= this.path.length - 1) {
    clearInterval(this.timer);
    this.active = 0;
    if (this.statement)
      eval(this.statement);
  } else {
    this.num++;
  }
}

function animate(interval) {
  if (this.active) return;
  this.num = 0;
  this.active = 1;
  this.timer = setInterval(this.name + ".step()", interval);
}

function slideBy(dx, dy, steps, interval, statement) {
  var fx = this.left();
  var fy = this.top();
  var tx = fx + dx;
  var ty = fy + dy;
  this.slideTo(tx, ty, steps, interval, statement);
}

function slideTo(tx, ty, steps, interval, statement) {
  var fx = this.left();
  var fy = this.top();
  var dx = tx - fx;
  var dy = ty - fy;
  var sx = dx / steps;
  var sy = dy / steps;

  var ar = new Array();
  for (var i = 0; i < steps; i++) {
    fx += sx;
    fy += sy;
    ar[i] = new pos(fx, fy);
  }
  this.path = ar;

  this.statement = (statement) ? statement : null;
  this.animate(interval);
}

function circle(radius, angle0, angle1, steps, -->
interval, statement) {
  var dangle = angle1 - angle0;
  var sangle = dangle / steps;
  var x = this.left();
  var y = this.top();
  var cx = x - radius * Math.cos(angle0 * Math.PI / 180);
  var cy = y + radius * Math.sin(angle0 * Math.PI / 180);

  var ar = new Array();
  for (var i = 0; i < steps; i++) {
    angle0 += sangle;
    x = cx + radius * Math.cos(angle0 * Math.PI / 180);
    y = cy - radius * Math.sin(angle0 * Math.PI / 180);
    ar[i] = new pos(x, y);
  }
  this.path = ar;

  this.statement = (statement) ? statement : null;
  this.animate(interval);
}