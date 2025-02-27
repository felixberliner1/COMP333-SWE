document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript loaded!");
   // Ensure all FAQ elements exist before adding event listeners
   let faqItems = document.querySelectorAll(".faq-question");
   if (faqItems.length > 0) {
   faqItems.forEach(item => {
   console.log("FAQ question found");
   item.addEventListener("click", function () {
   console.log("FAQ clicked");
   this.classList.toggle("open");
   let answer = this.nextElementSibling;
   if (answer) {
   answer.style.display = answer.style.display === "block" ? "none" : "block";
    }
    });
    });
    } else {
   console.warn("No FAQ items found!");
    }
   // Ensure menu toggle button exists before adding event listener
   let menuToggle = document.querySelector(".menu-toggle");
   let navLinks = document.querySelector(".nav-links");
   if (menuToggle && navLinks) {
   console.log("Menu toggle found!");
   menuToggle.addEventListener("click", function () {
   console.log("Menu clicked");
   navLinks.classList.toggle("active");
   let expanded = navLinks.classList.contains("active");
   this.setAttribute("aria-expanded", expanded);
    });
    } else {
   console.warn("Menu toggle or nav links not found!");
    }
   // Ensure skip link is focusable and improves accessibility
   let skipLink = document.querySelector(".skip-link");
   if (skipLink) {
   skipLink.addEventListener("click", function (e) {
   let mainContent = document.getElementById("main-content");
   if (mainContent) {
   e.preventDefault();
   mainContent.setAttribute("tabindex", "-1");
   mainContent.focus();
    }
    });
    }
   });