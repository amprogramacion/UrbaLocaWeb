class Casilla {
    constructor(x, y, w, h) {
        this.src = "casilla.png?1";
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