<script type="text/javascript">
  export default {
    props: ['attributes'],
    methods: {
      destroy() {
        axios.delete('/expenses/' + this.attributes.subject.id);

        $("#record"+this.attributes.id).fadeOut(300, () => {
          $("#deleteExpenseModal"+this.attributes.subject.id).modal("hide");
          flash("An expense has been deleted.");
        });
      }
    }
  }
</script>
