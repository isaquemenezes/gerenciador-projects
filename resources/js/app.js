import './bootstrap';

import autoDismissFlashMessage from './utils/flashMessage';
import initDeleteCard from './cards/deleteCard';
import initCreateCard from './cards/createCard';


$(document).ready(function () {
    initCreateCard();
    initDeleteCard();

    autoDismissFlashMessage();
});
