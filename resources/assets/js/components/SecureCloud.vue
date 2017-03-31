<template>
    <section id="cloud">

        <header>
            <h1 v-if="! isShare">Meine Dateien</h1>
            <h1 v-else>Dateifreigabe von {{ this.userName }}</h1>

            <div id="actions" v-if="! isShare">
                <md-button class="md-primary" @click.native="deleteFiles">
                    <md-icon>delete</md-icon>
                    <md-tooltip md-direction="top">Löschen</md-tooltip>
                </md-button>
                <md-button class="md-primary" @click.native="shareFiles">
                    <md-icon>share</md-icon>
                    <md-tooltip md-direction="top">Teilen</md-tooltip>
                </md-button>
                <!--<md-button class="md-primary">-->
                    <!--<md-icon>file_download</md-icon>-->
                    <!--<md-tooltip md-direction="top">Download</md-tooltip>-->
                <!--</md-button>-->
            </div>
        </header>

        <div id="no-files" v-if="files.length == 0">
            <p v-if=" ! isShare ">Fange an deine Dateien <span @click="triggerFileUpload">hochzuladen</span></p>
            <p style="text-align:left" v-else>Anscheinend hat der Besitzer die Dateien bereits gelöscht...</p>
        </div>

        <md-layout id="my-files" md-gutter v-else>
            <md-layout v-for="file in files" v-if="! searchMode || ( searchMode && searchResult.includes(file.id) )">
                <md-card>
                    <md-card-media>
                        {{ file.file_extension }}
                    </md-card-media>
                    <md-card-content>
                        <div class="filename">
                            <a :href="'/file/download/' + file.file_name" v-if="! isShare">
                                {{ file.file_name_original.substr(
                                    0, file.file_name_original.length - file.file_extension.length - 1
                                ) }}
                            </a>
                            <a :href="'/file/download/' + file.file_name + '/share/' + shareId" target="_self" v-else>
                                {{ file.file_name_original.substr(
                                    0, file.file_name_original.length - file.file_extension.length - 1
                                ) }}
                            </a>
                        </div>
                        <div class="action" v-if="! isShare">
                            <md-checkbox :id="file.file_name" name="selected" class="md-secondary" @change="changeFileSelection(file.id, file.file_name)"></md-checkbox>
                        </div>
                    </md-card-content>
                </md-card>
            </md-layout>
        </md-layout>
    </section>
</template>
<script>

    import Ajax from '../support/Ajax';
    import { EventBus } from '../support/EventBus';

    export default{

        props: ['initialFiles', 'shareId', 'userName'],

        data () {
            return {
                files: this.initialFiles,
                selected: [],
                isShare: false,
                searchMode: false,
                searchResult: []
            }
        },

        methods: {

            // in the current version of vue-material this could *not* be done with a v-model
            changeFileSelection: function(id, file_name) {

                var $element = $('#' + file_name);
                
                if( this.selected.includes(id) ) {
                    this.selected.splice(this.selected.indexOf(id), 1);
                } else {
                    this.selected.push(id);
                }
            },

            deleteFiles: function() {

                if( this.selected.length == 0 ) {
                    return Ajax.showInfoModal('Keine Dateien ausgewählt', '');
                }

                this.$http.post('/file/delete', JSON.stringify(this.selected)).then(response => {

                    Ajax.showAlert(response);

                    EventBus.$emit('fetch-files');

                });

            },

            triggerFileUpload: function() {
                $('#upload-file-input').trigger('click');
            },

            shareFiles: function() {

                if( this.selected.length == 0 ) {
                    return this.chooseFilesToShare();
                }

                // create file share
                this.$http.post('/share/create', JSON.stringify(this.selected)).then(response => {
                    Ajax.showAlert(response);
				    $('#share-link').val(response.data.link).select();
                });

                this.clearFileSelection();

            },

            chooseFilesToShare: function() {
                Ajax.showInfoModal('Keine Dateien ausgewählt', '<a id="go-to-shares" href="/share/index">Meine Dateifreigaben verwalten</a>');
            },

            // dirty implementing two-way data binding...
            clearFileSelection: function() {

                $('.md-checkbox.md-checked').find(':input').trigger('click');

                this.selected = [];

            }

        },

        created: function() {

            if( typeof this.shareId != 'undefined' ) {
                this.isShare = true;
            }

            EventBus.$on('fetch-files', function() {

                // fetch new files
                this.$http.get('/').then(function(response) {
                    this.files = response.data;
                }, () => {
                    location.reload();
                });

                this.clearFileSelection();

            }.bind(this));


            EventBus.$on('search-files', function(query) {

                // toggle search mode
                this.searchMode = query.length > 0 ? true : false;

                // clear search result
                this.searchResult = [];

                // iterate through files
                this.files.forEach(function(item) {

                    // if file name or extension matches, mark item as result
                    if( item.file_name_original.includes(query) || item.file_extension == query) {
                        this.searchResult.push(item.id);
                    }

                }.bind(this))

            }.bind(this));

        }
    }
</script>
