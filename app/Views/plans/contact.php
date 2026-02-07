<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center px-4">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-8">
    
    <h2 class="text-3xl font-bold text-gray-800 text-center">
        Contact Us
    </h2>
    <p class="text-gray-500 text-center mt-2">
        Have questions? We’re happy to help.
    </p>

    <!-- Success Message -->
    <div id="successMsg"
         class="hidden mt-4 text-green-600 text-center font-medium">
        Message sent successfully
    </div>

    <form id="contactForm"
          method="post"
          action="<?= BASE_URL ?>/contact-submit"
          class="mt-6 space-y-5">

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Name
            </label>
            <input type="text" name="name" required
                   class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Email
            </label>
            <input type="email" name="email" required
                   class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Message
            </label>
            <textarea name="message" rows="4" required
                      class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold
                       hover:bg-blue-700 transition">
            Send Message
        </button>

    </form>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('successMsg').classList.remove('hidden');
            form.reset();

            // redirect to login after 3 seconds
            setTimeout(() => {
                window.location.href = "<?= BASE_URL ?>/login";
            }, 3000);

        } else {
            alert(data.message || 'Something went wrong');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Server error');
    });
});
</script>


</body>
</html>