<script type="text/javascript">
  export default {
    data() {
      return {
              editing: false,
              amount: this.expense.amount,
      };
    },

    props: ['attributes', 'expense'],
    methods: {
      update() {
        axios.patch('/expenses/' + this.expense.id, {
          amount: this.amount,
          name: this.expense.name,
        });

        this.editing = false;

        flash("Expense has been updated!");
      },

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
