import { registerReactControllerComponents } from '@symfony/ux-react';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));