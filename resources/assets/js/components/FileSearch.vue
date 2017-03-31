<template>
    <div id="search" :class="{ active: isActive }">
        <md-input-container md-inline>
            <md-icon>search</md-icon>
            <label>Search</label>
            <md-input type="text" @input="emitQuery"></md-input>
        </md-input-container>
    </div>
</template>

<script>

    import { EventBus } from '../support/EventBus';

    export default {

       data() {
           return {
               isActive: false
           }
       },

       methods: {

           emitQuery: function(string) {

               this.isActive = string.length > 0 ? true : false;

               EventBus.$emit('search-files', string);

           },

           toggleClass: function() {
               console.debug("toggle class");
           }

       }
    }
</script>
