<script type="text/javascript">
  export default {
    data() {
      return {
        equal: true,
        total: 0,
        member: {
          partial: []
        },
        left: 0,
        name: ""
      };
    },

    props: ['attributes'],
    methods: {
      setLimit() {
        var partials = 0;
        for (var i = 0; i < this.member.partial.length; i++) {
          if(parseInt(this.member.partial[i]) >= 0) {
            partials += parseInt(this.member.partial[i]);
          }
        }

        if(this.total > 0)
          this.left = this.total - partials;
      },

      setEqual(val) {
        this.equal = (parseInt(val) == 0 ? false : true);
        $(".selectpicker").selectpicker('deselectAll');
      }
    }
  }
</script>
