<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contact Form Section -->
            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Get in Touch</h1>
                    <p class="text-lg text-gray-700 mb-6">
                        We’d love to hear from you! Whether you have a question, feedback, or need support, fill out the form below and we’ll get back to you as soon as possible.
                    </p>
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] sm:text-sm" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] sm:text-sm" required>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" id="subject" name="subject" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] sm:text-sm" required>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] sm:text-sm" required></textarea>
                        </div>
                        <div>
                            <button type="submit" class="inline-block bg-[var(--primary-color)] text-white px-6 py-2 rounded-md hover:bg-[var(--primary-color-dark)] transition-colors duration-200">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Contact Info Section -->
            <section class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Reach Out</h3>
                            <p class="text-gray-700">
                                <span class="font-medium">Email:</span> <a href="mailto:support@businesscart.ai" class="text-[var(--primary-color)] hover:underline">support@businesscart.ai</a>
                            </p>
                            <p class="text-gray-700">
                                <span class="font-medium">Phone:</span> (123) 456-7890
                            </p>
                            <p class="text-gray-700">
                                <span class="font-medium">Hours:</span> Mon-Fri, 9 AM - 5 PM
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Our Location</h3>
                            <p class="text-gray-700">
                                123 Commerce Street<br>
                                Shop City, SC 45678<br>
                                United States
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Map Placeholder Section -->
            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Find Us</h2>
                    <div class="w-full h-64 bg-gray-200 rounded-md flex items-center justify-center">
                        <p class="text-gray-600">Map Placeholder (Embed your map here)</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>