<form class="callback" method="POST" action="{{ route('enquiry.store') }}#faq" novalidate>
          @csrf
          <input type="hidden" name="page" value="home (call me back)">
          <input type="hidden" name="type" value="Call Me Back">
          <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
          <b>Rather talk it through? We'll call you.</b>
          <label class="sr-only" for="c-name">Your name</label>
          <input id="c-name" type="text" name="name" placeholder="Your name" required autocomplete="name">
          <label class="sr-only" for="c-phone">Phone number</label>
          <input id="c-phone" type="tel" name="phone" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel">
          <button class="btn btn-primary" type="submit">Call Me Back</button>
          <small>No sales pressure · Mon–Fri, 10am–6pm</small>
        </form>