import request from "./request.js";
import {
  validateRequirements,
  createErrors
} from './http_error.js';

const canReview = (document.getElementById('review-form-row')) != null;



if (canReview) {
  const starsElem = document.getElementById('review-form-stars');
  const reviewForm = document.getElementById('review-form');
  const select = document.getElementById('select-order-Id');
  let stars = [];
  let starRating = 1;
  let errors;


  reviewForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    let validation = ['reviewDescription'];
    let validationErrors = validateRequirements(validation);

    errors && errors.remove();
    if (validationErrors) {
      document.querySelector('#submit-button').prepend(validationErrors);
      errors = validationErrors;
    }

    let form = {
      'id_order': select.options[select.selectedIndex].value,
      'id_product': document.getElementById('id_product').value,
      'rating': starRating,
      'description': document.getElementById('reviewDescription').value
    }
    console.log(form);

    const postForm = async () => {
      const response = await request({
        url: "/review",
        method: 'POST',
        content: form
      }, true);
      return response
    }

    if (!validationErrors) {
      let response;
      try {
        response = await postForm();
        
      } catch (error) {
        response = error;
      }

      console.log(response)

      if (response.status == 200) {
        location.reload();

      } else if (response.status == 400) {
        let submitErrors = [];
        for (let key in response.message) {
            for (let error in response.message[key]) {
              submitErrors.push({
                'id': "",
                'message': response.message[key][error]
              });
            }
        }
        submitErrors = createErrors(submitErrors);
        document.querySelector('#submit-button').prepend(submitErrors);
        errors = (errors != null) ? errors.concat(submitErrors) : submitErrors;
      }
    }
  });


    for (let i = 0; i < starsElem.children.length; i++) {
      const star = starsElem.children[i];
      stars.push(star);

      const addStars = clicked => {
        for (let j = 0; j <= i; j++) {
          stars[j].classList.replace('far', 'fas');
          clicked && stars[j].classList.add('clicked');
        }

        for (let j = i + 1; j < 5; j++) {
          stars[j].classList.replace('fas', 'far');
          clicked && stars[j].classList.remove('clicked');
        }
      };

      const removeStars = () => {
        stars.forEach(star => {
          if (star.className.search('clicked') == -1) {
            star.classList.replace('fas', 'far');
          } else if (star.className.search('fas') == -1) {
            star.classList.replace('fas', 'far');
          }
        });
      };

      star.addEventListener('mouseenter', () => addStars(false));
      star.addEventListener('mouseleave', removeStars);

      star.addEventListener('click', () => {
        addStars(true);
        starRating = i + 1;
      });

    };

  }