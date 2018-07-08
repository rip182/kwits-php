<leech inline-template :attributes="{{ $members }}" v-cloak>
  <div class="leech">
    <form class="search-form" action="/expenses" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="travel_id" value="{!! $travel->id !!}">
      <input type="hidden" name="split" :value="split">
      <input class="members" v-on:input="setLimit" v-model="total" name="amount" type="number" id="total-amount" placeholder="P 0.00 *" autofocus>
      <input class="members" v-model="name" name="name" type="text" placeholder="e.g. Dinner, Bus Fare, etc.">
      <div v-show="split == 'equal'">
        <select data-style="members" id="members" name="user_id[]" class="form-control selectpicker" data-actionsBox="true" multiple data-selected-text-format="count > 3">
          @foreach($travel_buddies as $member)
            <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
          @endforeach
        </select>
      </div>
      <div v-if="split == 'unequal'" style="margin-top: 10px;">
        @foreach($travel_buddies as $member)
            <label for="" class="">{{ $member['name'] }}</label>
            <input name="user_id[{{$member['id']}}]" v-on:input="setLimit" v-model="member.partial[{{$member['id']}}]" type="number" class="" placeholder="0.00" value="0.00">
        @endforeach
      </div>
      <p>&nbsp;</p>
      <div class="contact-item form-submit">
        <button v-if="split == 'equal'" type="button" class="btn btn-link" name="button" @click="setSplit('unequal')">Unequal</button>
        <button v-else type="button" class="btn btn-link" name="button" @click="split = 'equal'">Equal</button>
        <input name="submit" type="submit" id="submit" class="submit" value="Submit">
      </div>
      <div class="kd-close">
      </div>
    </form>
  </div>
</leech>
