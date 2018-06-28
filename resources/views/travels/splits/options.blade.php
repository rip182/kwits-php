<leech inline-template :attributes="{{ $members }}" v-cloak>
  <div class="leech">
    <form action="/expenses" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="travel_id" value="{!! $travel->id !!}">
      <input type="hidden" name="split" :value="split">
      <div class="form-group">
        <input v-on:input="setLimit" v-model="total" name="amount" type="number" id="total-amount" class="form-control" placeholder="0.00" autofocus>
      </div>
      <div class="form-group">
        <input v-model="name" name="name" type="text" class="form-control" placeholder="e.g. Dinner, Bus Fare, etc.">
      </div>
      <div v-show="split == 'equal'">
        <select id="members" name="user_id[]" class="form-control selectpicker" data-actionsBox="true" multiple data-selected-text-format="count > 3">
          @foreach($members as $member)
            <option value="{{ $member->user_id }}">{{ $member->user->name }}</option>
          @endforeach
        </select>
      </div>
      <div v-if="split == 'unequal'">
        @foreach($members as $member)
        <div class="form-group form-group-sm">
            <label for="" class="col-sm-2 control-label">{{ $member->user->name }}</label>
            <div class="col-sm-10 col-lg-3 col-lg-offset-7">
              <input name="user_id[{{$member->user_id}}]" v-on:input="setLimit" v-model="member.partial[{{$member->user_id}}]" type="number" class="form-control" placeholder="0.00" value="0.00">
            </div>
        </div>

        @endforeach
      </div>
      <button v-if="split == 'equal'" type="button" class="btn btn-link" name="button" @click="setSplit('unequal')">Unequal</button>
      <button v-else type="button" class="btn btn-link" name="button" @click="split = 'equal'">Equal</button>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</leech>
