import { startStimulusApp } from '@symfony/stimulus-bridge';

import Sidebar from './AdminBundle/js/controllers/sidebar_controller'
import Collapser from './UiBundle/js/controllers/collapser_controller'
import Grid from './UiBundle/js/controllers/grid_controller'
import SwitcherField from './UiBundle/js/controllers/switcher-field_controller'
import Tabs from './UiBundle/js/controllers/tabs_controller'
import Toolbar from './UiBundle/js/controllers/toolbar_controller'
import Tree from './UiBundle/js/controllers/tree_controller'
import ConfigMenu from './ConfigBundle/js/controllers/config-menu_controller'

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!',
    true,
    /\.[jt]sx?$/
));
// register any custom, 3rd party controllers here
app.register('sidebar', Sidebar);
app.register('collapser', Collapser);
app.register('grid', Grid);
app.register('switcher-field', SwitcherField);
app.register('tabs', Tabs);
app.register('toolbar', Toolbar);
app.register('tree', Tree);
app.register('config-menu', ConfigMenu);
