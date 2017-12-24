<payment inline-template :attributes="{{ $activity }}" :friends="{{ $friends }}" :recipient="{{ $activity->subject->payable }}">
  <div class="payment">
    <h5 style="float:left;">Paid</h5>
    <div class="dropdown" style="float:right;">
      <i type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon-ellipsis-horizontal"></i>
      <ul class="dropdown-menu" aria-labelledby="dLabel">
          <li>
            <a @click="editing = true">Edit</a>
          </li>
          <li>
            <a data-toggle="modal" data-target="#deletePaymentModal{{ $activity->subject->id }}" data-payment-id="{{ $activity->subject->id }}" href="#">Delete</a>
          </li>
      </ul>
    </div>
    <div style="clear:both;"></div>
    <h5>
      <small class="text-muted">
        You paid
        {{ ($activity->subject->payable_type == "App\User" ? "" : "for" )}}
        <select v-if="editing" v-model="borrower">
          <option :value="friend" v-for="friend in friends"> @{{ friend.name }}</option>
        </select>
        <strong v-else v-text="borrower.name"> {{ $activity->subject->payable->name }} </strong>
      </small>
      <a href="#"><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></a>
      <span style="float:right; color:green;">
        <strong>+ Php
          <span v-if="editing">
            <input type="number" name="" v-model="amount">
            <button class="btn btn-success btn-xs" type="button" name="button" @click="update">Update</button>
            <button type="button" class="btn btn-link btn-xs" name="button" @click="editing = false">Cancel</button>
          </span>
          <span v-else v-text="amount">
            {{ number_format($activity->subject->amount, 2) }}
          </span>
        </strong>
      </span>
    </h5>
    @include("profiles.modals.delete_payment")
  </div>
</payment>
