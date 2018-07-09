<lend inline-template :attributes="{{ $activity }}" :friends="{{ $friends }}" :recipient="{{ $activity->subject->recipient }}" v-cloak>
  <div class="lend">
    <div class="dropdown col-md-1 col-md-push-10">
      <i type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon-ellipsis-horizontal"></i>
      <ul class="dropdown-menu" aria-labelledby="dLabel">
          <li>
            <a @click="editing = true">Edit</a>
          </li>
          <li>
            <a data-toggle="modal" data-target="#deleteLendModal{{ $activity->subject->id }}" data-lending-id="{{ $activity->subject->id }}" href="#">Delete</a>
          </li>
      </ul>
    </div>
    <div style="clear:both;"></div>
    <h5>
      <small class="text-muted">
        You lent money to
        <select v-if="editing" v-model="lendee">
          <option :value="friend" v-for="friend in friends"> @{{ friend.name }}</option>
        </select>
        <strong v-else v-text="lendee.name"></strong>
      </small>
      <span style="float:right;">Php
          <span v-if="editing">
            <input type="number" name="" v-model="amount">
            <button class="btn btn-success btn-xs" type="button" name="button" @click="update">Update</button>
            <button type="button" class="btn btn-link btn-xs" name="button" @click="editing = false">Cancel</button>
          </span>
          <span v-else v-text="amount">
            {{ number_format($activity->subject->amount, 2) }}
          </span>
      </span>
      <small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small>
    </h5>

    @include("profiles.modals.delete_lend")
  </div>
</lend>
