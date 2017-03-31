export default {

    constructor() {
        this.videoDimensions,
        this.$video,
        this.$canvas;
    },

    init() {

        this.$video  = $('#video');
        this.$canvas = $('#canvas');

        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {

            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {

                var video = document.getElementById('video');

                video.src = window.URL.createObjectURL(stream);

                video.play();

            });

        }

    },

    takePhoto() {

        this.getVideoElementDimensions();

        this.drawAndDisplayCanvas();

    },

    getVideoElementDimensions() {

        this.videoDimensions = {
            'w': this.$video.outerWidth(),
            'h': this.$video.outerHeight()
        };

    },

    drawAndDisplayCanvas() {

        let w = this.videoDimensions.w,
            h = this.videoDimensions.h;

        this.$canvas.attr({
            'width'  : w,
            'height' : h
        }).fadeIn('slow');

        this.$canvas[0].getContext('2d').drawImage(this.$video[0], 0, 0, w, h);

    },

    exportImage() {

        return this.$canvas[0].toDataURL("image/png", 1);

    }

};