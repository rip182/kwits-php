<script type="text/javascript">
  export default {
    props: ['attributes'],
    methods: {
      destroy() {
        axios.delete('/lendings/' + this.attributes.subject.id);

        $("#record"+this.attributes.id).fadeOut(300, () => {
          $("#deleteLendModal"+this.attributes.subject.id).modal("hide");
          flash("A lend activity has been deleted.");
        });
      }
    }
  }
</script>
