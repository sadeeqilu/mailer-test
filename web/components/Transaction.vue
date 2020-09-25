<template>
  <div class="transaction">
    <b-form @submit.prevent="makeTransaction()" method="post">
                <b-form-group id="input-group-1" label="To:" label-for="input-1">
                  <b-form-input
                    id="input-1"
                    size="sm"
                    v-model="payment.to"
                    type="number"
                    required
                    placeholder="Destination ID"
                  ></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
                  <b-input-group prepend="$" size="sm">
                    <b-form-input
                      id="input-2"
                      v-model="payment.amount"
                      type="number"
                      required
                      placeholder="Amount"
                    ></b-form-input>
                  </b-input-group>
                </b-form-group>

                <b-form-group id="input-group-3" label="Details:" label-for="input-3">
                  <b-form-input
                    id="input-3"
                    size="sm"
                    v-model="payment.details"
                    required
                    placeholder="Payment details"
                  ></b-form-input>
                </b-form-group>

                <b-button type="submit" size="sm" variant="primary">Submit</b-button>
              </b-form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data(){
    return{
      payment: [],
      transactions: []
    }
  },
  methods:{
    makeTransaction() {
      var that = this
      const config = {
        headers: {
          Accept: "application/json"
        }
      };
      axios.post(`http://localhost:8000/api/transactions/make-transaction/${this.$route.params.id}`,{
        'to':that.payment.to,
        'amount' : that.payment.amount,
        'details' : that.payment.details
    }
    ,config)
      .then((res) => {
        that.payment = {};
        that.show = false;
        this.$emit('transactions-update');
          })


    }
  }
}
</script>

<style scoped>

</style>
