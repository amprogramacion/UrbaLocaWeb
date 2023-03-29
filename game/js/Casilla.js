class Casilla {
    constructor(src, x, y, w, h) {
        this.src = src;
        this.img = null;
        this.pos_x = 0;
        this.pos_y = 0;
        this.x = x;
        this.y = y;
        this.width = w;
        this.height = h;
        this.furnis = [];
        this.user = null;
        this.walkable = true;
    }
}