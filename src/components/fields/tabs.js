import '../css/panelTabs.scss';
import PropTypes from 'prop-types';
import classnames from 'classnames';
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { Tooltip } = wp.components;

export default class Tabs extends Component {
    constructor(props) {
        super(props);
        this.state = {
            activeTab: this.props.children[0].props.tabTitle
        }
    }
    render() {
        let TEMPTAG = Fragment;
        const tabs = this.props.children,
            { activeTab } = this.state,
            { label, panelGroup } = this.props;

        const className = classnames(
            'wprig-field',
            'wprig-field-tabs',
            {'panel-group': panelGroup},
            {'wprig-has-label': typeof label !== 'undefined'}
        );

        if (panelGroup) {
            TEMPTAG = 'Div'
        }
        return (
            <div className={className}>
                <div className="wprig-field-tab-header">
                    {label && <label>{label}</label>}
                    <div className="wprig-field-tab-menus">
                        {tabs.map(tab =>
                            <Tooltip text={__(tab.props.tabTitle)} >
                                <TEMPTAG {...panelGroup && { className: 'tab-menu-wrapper' }}>
                                    {
                                        panelGroup && <svg width="21" height="18" viewBox="0 0 21 18" xmlns="http://www.w3.org/2000/svg"><g transform="translate(-29 -4) translate(29 4)" fill="none"><path d="M1 .708v15.851" className="wprig-svg-stroke" stroke-linecap="square" /><rect className="wprig-svg-fill" x="5" y="5" width="16" height="7" rx="1" /></g></svg>
                                    }
                                    <button
                                        onClick={() => this.setState({ activeTab: tab.props.tabTitle })}
                                        className={'wprig-tab-menu ' + (tab.props.tabTitle === activeTab ? 'active' : '')}
                                    >
                                        {tab.props.tabTitle}
                                    </button>
                                </TEMPTAG>
                            </Tooltip>
                        )}
                    </div>
                </div>
                <div className="wprig-field-tab-items">
                    {tabs.map(tab => tab.props.tabTitle === activeTab ? tab : '')}
                </div>
            </div>
        )
    }
}

Tabs.PropTypes = {
    tabs: PropTypes.element.isRequired
};