/* global estructura */

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
        this.pos_caminar_x = 0;
        this.pos_caminar_y = 0;
        this.casilla = null;
        this.caminando = false;
        this.caminos_recorridos = 0;
        this.prox_casilla = null;
        this.timestamp_start_casilla = null;
        this.tiempo_por_casilla = 350;
        this.tiempo_por_paso = 350;
        this.mirando = 1;
        this.frameCaminar = 1;
    }
    caminar() {

        //Cargar la posición mirando
        if (!this.caminos.length) {
            // No hay caminos, entonces no se ejecuta la funcion.
            return;
        }

        var timestamp = (new Date()).getTime();
        if (this.prox_casilla == null) {
            this.prox_casilla = this.caminos[this.caminos_recorridos];
            this.timestamp_start_casilla = timestamp;
        }

        var progreso = (timestamp - this.timestamp_start_casilla) / this.tiempo_por_casilla;
        var progreso_paso = (timestamp - this.timestamp_start_casilla) / this.tiempo_por_paso;
        
        if(progreso_paso >= 1) {
            this.frameCaminar++;
            if(this.frameCaminar > 4) {
                this.frameCaminar = 1;
            }
        }

        // Si el progreso es uno, ya superó el trayecto, y avanzamos con más caminos
        if (progreso >= 1) {
            this.x = this.prox_casilla[0];
            this.y = this.prox_casilla[1];
            this.casilla = estructura.casillas[this.prox_casilla[0]][this.prox_casilla[1]];

            // Restablecer posición de la caminata
            this.pos_caminar_x = 0;
            this.pos_caminar_y = 0;
            
            this.prox_casilla = null;
            this.caminos_recorridos++;

            // Si ya se terminaron todos los caminos, la caminata se detiene y ya no se ejecutará más "calcularcaminata"
            if (this.caminos_recorridos >= this.caminos.length) {
                this.caminos = [];
                this.caminos_recorridos = 0;
                this.caminando = false;
            } else {
                this.caminando = true;
            }
        } else { 
            var casillaDestino = estructura.casillas[this.prox_casilla[0]][this.prox_casilla[1]];
            
            
            if(this.x < casillaDestino.x && this.y == casillaDestino.y) {
                this.mirando = 2;
            }
            if(this.x > casillaDestino.x && this.y == casillaDestino.y) {
                this.mirando = 4;
            }
            if(this.y < casillaDestino.y && this.x == casillaDestino.x) {
                this.mirando = 1;
            }
            if(this.y > casillaDestino.y && this.x == casillaDestino.x) {
                this.mirando = 3;
            }
            
            console.log("x: "+this.x+" y: "+this.y+" cDx: "+casillaDestino.x+" cDy: " +casillaDestino.y+" Mirando "+this.mirando+ "Fc: "+this.frameCaminar);
            
            var trayecto_pos_x = casillaDestino.pos_x - this.casilla.pos_x;
            var trayecto_pos_y = casillaDestino.pos_y - this.casilla.pos_y;
            this.pos_caminar_x = trayecto_pos_x * progreso;
            this.pos_caminar_y = trayecto_pos_y * progreso;
        }
    }
}