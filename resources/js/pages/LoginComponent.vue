<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login Component</div>

          <div class="card-body">
            <form action="#">
              <div>
                <label for="email">Email address</label>
                <input type="text" name="email" id="email" />
              </div>
              <div>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" />
              </div>
              <div>
                <button type="submit">Sign in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
