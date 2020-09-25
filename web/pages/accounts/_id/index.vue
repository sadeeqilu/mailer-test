<template>
  <div>
    <div class="container" v-if="loading">loading...</div>

    <div class="container" v-if="!loading">
      <b-card :header="'Welcome, ' + account.name" class="mt-3">
        <b-card-text>
          <div>
            Account: <code>{{ account.name }}</code>
          </div>
          <div>
            Balance:
            <code
              >{{ account.currency === "usd" ? "$" : "€"
              }}{{ account.balance }}</code
            >
          </div>
        </b-card-text>
        <b-button size="sm" variant="success" @click="show = !show">New payment</b-button>

        <b-button
          class="float-right"
          variant="danger"
          size="sm"
          nuxt-link
          to="/"
          >Logout</b-button>
      </b-card>

      <b-card class="mt-3" header="New Payment" v-show="show">
        <Transaction/>
      </b-card>

      <b-card class="mt-3" header="Payment History">
        <b-table striped hover :items="transactions"></b-table>
      </b-card>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Account from "@/components/Account.vue";
import Transaction from "@/components/Transaction";
export default {
  components: {
    Account, Transaction
  },

  data() {
    return {
      show: false,
      // payment: [],

      account: [],
      transactions: [],
      //
      loading: true
    };
  },

  async created() {
    const config = {
      headers: {
        Accept: "application/json"
      }
    };

    try{
      let id = this.$route.params.id
      const get_account = await axios.get(`http://localhost:8000/api/accounts/${id}`,config);
      this.account = get_account.data.data;
      const get_transactions = await axios.get(`http://localhost:8000/api/transactions/get-transaction/${id}`,config)
       let temp_transactions = get_transactions.data.data;
      for (let i=0;i <= temp_transactions.length;i++) {
        let transaction = {
          "from": temp_transactions[i].debited.name,
          "to": temp_transactions[i].credited.name,
          "amount": (temp_transactions[i].debited.name === this.account.name ? "- " : "+ ") +
            (temp_transactions[i].currency === 'usd' ? '$' : '€') + temp_transactions[i].amount,
          "details" : temp_transactions[i].details
        };
        this.transactions.push(transaction);
      }
      if (this.account && this.transactions) {
        this.loading = false;
      }
    }catch (e) {
      console.log(e)
      this.loading = false
    }
  },
  mounted() {
    this.$on('transaction-update',async function (){
      await this.created()
    })
  },
  // mounted() {
  //   // const that = this;
  //
  //   axios
  //     .get(`http://localhost:8000/api/accounts/1`)
  //     .then(function(response) {
  //
  //       // if (!response.data.data.length) {
  //       //   window.location = "/";
  //       // } else {
  //       //   th.account = response.data.data;
  //
  //         // if (that.account && that.transactions) {
  //         //   that.loading = false;
  //         // }
  //       // }
  //     });
  //
  //   axios
  //     .get(
  //       `http://localhost:8000/api/accounts/${
  //         that.$route.params.id
  //       }/transactions`
  //     )
  //     .then(function(response) {
  //       that["transactions"] = response.data.data;
  //
  //       var transactions = [];
  //       for (let i = 0; i < that.transactions.length; i++) {
  //         that.transactions[i].amount =
  //           (that.account.currency === "usd" ? "$" : "€") +
  //           that.transactions[i].amount;
  //
  //         if (that.account.id != that.transactions[i].to) {
  //           that.transactions[i].amount = "-" + that.transactions[i].amount;
  //         }
  //
  //         transactions.push(that.transactions[i]);
  //       }
  //
  //       that.transactions = transactions;
  //
  //
  //     });
  // },

  // methods: {
  //   onSubmit(evt) {
  //     var that = this;
  //
  //     evt.preventDefault();
  //
  //     axios.post(
  //       `http://localhost:8000/api/accounts/${
  //         this.$route.params.id
  //       }/transactions`,
  //
  //       this.payment
  //     );
  //
  //     that.payment = {};
  //     that.show = false;
  //
  //     // update items
  //     setTimeout(() => {
  //       axios
  //         .get(`http://localhost:8000/api/accounts/${this.$route.params.id}`)
  //         .then(function(response) {
  //           if (!response.data.length) {
  //             window.location = "/";
  //           } else {
  //             that.account = response.data[0];
  //           }
  //         });
  //
  //       axios
  //         .get(
  //           `http://localhost:8000/api/accounts/${
  //             that.$route.params.id
  //           }/transactions`
  //         )
  //         .then(function(response) {
  //           that["transactions"] = response.data;
  //
  //           var transactions = [];
  //           for (let i = 0; i < that.transactions.length; i++) {
  //             that.transactions[i].amount =
  //               (that.account.currency === "usd" ? "$" : "€") +
  //               that.transactions[i].amount;
  //
  //             if (that.account.id != that.transactions[i].to) {
  //               that.transactions[i].amount = "-" + that.transactions[i].amount;
  //             }
  //
  //             transactions.push(that.transactions[i]);
  //           }
  //
  //           that.transactions = transactions;
  //         });
  //     }, 200);
  //   }
  // }
  head(){
    return{
      title : this.account.name,
      meta : [
        {
          hid : "description",
          name : "description",
          content : "MailerLite assignment test"
        }
      ]
    }
  }
};
</script>
