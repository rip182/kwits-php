<script type="text/javascript">
  export default {
    props: ['attributes'],
    methods: {
      destroy() {
        axios.delete('/payments/' + this.attributes.subject.id);

        $("#record"+this.attributes.id).fadeOut(300, () => {
          $("#deletePaymentModal"+this.attributes.subject.id).modal("hide");
          flash("A payment has been cancelled.");
        });
      }
    }
  }
</script>
