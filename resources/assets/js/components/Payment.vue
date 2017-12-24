<script type="text/javascript">
  export default {
    data() {
      return {
              editing: false,
              amount: this.attributes.subject.amount,
              recipients: this.friends,
              borrower: this.recipient,
      };
    },

    props: ['attributes', 'friends', 'recipient'],
    methods: {
      update() {
        axios.patch('/payments/' + this.attributes.subject.id, {
          amount: this.amount,
          payable_id: this.borrower.id,
        });

        this.editing = false;

        flash("Payment has been updated!");
      },

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
