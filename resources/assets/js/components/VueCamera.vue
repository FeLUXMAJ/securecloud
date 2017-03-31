<template>

    <div id="vue-camera">
        <video id="video" autoplay></video>

        <canvas id="canvas"></canvas>

        <div id="take-photo">
            <md-icon @click.native="takePhoto">
                photo_camera
                <md-tooltip md-direction="top">Tipp: Mit Leertaste kannst du das Foto auch aufnehmen.</md-tooltip>
            </md-icon>
        </div>

        <!--<md-bottom-bar md-theme="inverted">-->
            <!--<md-bottom-bar-item md-icon="cached" class="display-none"></md-bottom-bar-item>-->
            <!--<md-bottom-bar-item @click.native="takePhoto" md-icon="photo_camera" md-active></md-bottom-bar-item>-->
            <!--<md-bottom-bar-item md-icon="done" class="display-none"></md-bottom-bar-item>-->
        <!--</md-bottom-bar>-->

        <!--<md-button class="md-icon-button md-raised"  @click.native="takePhoto">-->
            <!--<md-icon>done</md-icon>-->
        <!--</md-button>-->

        <!--<md-button class="md-icon-button md-raised"  @click.native="takePhoto">-->
            <!--<md-icon>cached</md-icon>-->
        <!--</md-button>-->

        <!--<input type="text" id="vue-camera-export" v-model="photo">-->

    </div>

</template>

<script>

    import Camera from '../support/Camera';
    import { EventBus } from '../support/EventBus';

    export default {

        name: 'vue-camera',

        props: ['type'],

        methods: {

            takePhoto: function () {

                Camera.takePhoto();

                if(this.type == 'login') {
                    EventBus.$emit('do-login');
                }

            },

            bindEventListeners: function() {

                // back up this context
                var instance = this;

                // bind spacebar key
                $('body').bind('keypress', function(e) {

                    var elem = e.target.tagName.toLowerCase();

                    if (e.which == 32 && elem != 'input') {
                        instance.takePhoto();
                    }

                });

            }

        },
        mounted: () => {

            Camera.init();

        },
        created : function() {

            this.bindEventListeners();

        }
    }

</script>
