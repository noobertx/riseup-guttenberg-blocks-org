import './style.scss';
import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks; 

registerBlockType('wprig/yanicountdown', {
    title: __('Simple CountDown'),
    category: 'wprig-blocks',
    icon: 'universal-access-alt',
    description: __('Simple CountDown.'),
    supports: {
        align: [
            'full',
            'wide',
            'center'
        ],
    },
    keywords: [
        __('link'),
        __('button')
    ],
    example:{},
    edit: Edit,
    save: function (props) {
        return null;
    }
})