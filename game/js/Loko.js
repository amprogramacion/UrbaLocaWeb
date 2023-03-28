class Loko {
    constructor(image_src) {
        this.image_src = image_src;
        this.img = null;
        this.socket = null;
        this.nombre = null;
        this.id = null;
        this.casillas = [];
        this.caminos = [];
        this.pos_x = 12;
        this.pos_y = -70;
        this.x = null;
        this.y = null;
        this.pos_caminar_x = null;
        this.pos_caminar_y = null;
    }
}