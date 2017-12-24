<script type="text/javascript">
  export default {
    data() {
      return {
              editing: false,
              amount: this.attributes.subject.amount,
              recipients: this.friends,
              lendee: this.recipient,
      };
    },
    
    props: ['attributes', 'friends', 'recipient'],
    methods: {
      update() {
        axios.patch('/lendings/' + this.attributes.subject.id, {
          amount: this.amount,
          recipient_id: this.lendee.id,
        });

        this.editing = false;

        flash("Lend has been updated!");
      },

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
