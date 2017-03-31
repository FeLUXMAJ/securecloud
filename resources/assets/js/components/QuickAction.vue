<template>
    <div id="quick-action">

        <md-button class="md-fab md-fab-bottom-right" @click.native="triggerFileUpload">
            <md-icon>cloud_upload</md-icon>
        </md-button>

        <md-spinner id="uploading-files" :md-size="74" :md-stroke="2.2" md-indeterminate></md-spinner>

        <form id="upload-file" class="display-none">
            <input type="file" name="file" id="upload-file-input" @change="uploadFiles" multiple>
        </form>

    </div>
</template>

<script>

    import Ajax from '../support/Ajax';
    import { EventBus } from '../support/EventBus';

    export default{
        data () {
            return{
                files: {},
                notUploaded: []
            }
        },

       methods: {

           triggerFileUpload: function() {
                $('#upload-file-input').trigger('click');
           },

           uploadFiles: function(value) {

                // show spinner
                $('#uploading-files').fadeIn("slow");

                // create new formdata element
                var formData = new FormData();

                // get files
                this.files = value.srcElement.files;

                // append files to formdata
                for (var i = 0; i < this.files.length; i++) {
                    if( this.files[i].size / 1024 / 1024 < 25 ) {
                        formData.append('files[]', this.files[i], this.files[i].name);
                    } else {
                        this.notUploaded.push(this.files[i].name);
                    }
                }

                // upload files
                this.$http.post('/file/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function(response) {
                    this.refreshView(response); // success callback
                }, function(response) {
                    this.refreshView(response); // error callback
                    Ajax.handleServerError(response, "Folgende Dateien sind zu groß für den Upload: <br>" + this.notUploaded.join(', '));
                });

           },

           refreshView: function(response) {

                $('#uploading-files').fadeOut("slow");
                $('#upload-file-input').val("");

                Ajax.showAlert(response);

                EventBus.$emit('fetch-files');

           }

       }
    }
</script>
