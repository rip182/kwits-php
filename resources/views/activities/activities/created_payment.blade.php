<payment inline-template :attributes="{{ $activity }}" :friends="{{ $friends }}" :recipient="{{ $activity->subject->payable }}" v-cloak>
  <div class="payment">
    <h6>
      <small class="text-muted">
        You paid
        {{ ($activity->subject->payable_type == "App\User" ? "" : "for" )}}
        <select v-if="editing" v-model="borrower">
          <option :value="friend" v-for="friend in friends"> @{{ friend.name }}</option>
        </select>
        <strong v-else v-text="borrower.name"> {{ $activity->subject->payable->name }} </strong>
      </small>
      <a href="#"><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></a>
      <span style="float:right;">
        Php
          <span v-if="editing">
            <input type="number" name="" v-model="amount">
            <button class="btn btn-success btn-xs" type="button" name="button" @click="update">Update</button>
            <button type="button" class="btn btn-link btn-xs" name="button" @click="editing = false">Cancel</button>
          </span>
          <span v-else v-text="amount">
            {{ number_format($activity->subject->amount, 2) }}
          </span>

      </span>
    </h6>
    @include("profiles.modals.delete_payment")
  </div>
</payment>
