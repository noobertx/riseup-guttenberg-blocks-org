import Url from "./url";
import Media from './media';
import Color from "./color";
import Select from './select';
import Gradient from './gradient';
import ButtonGroup from "./buttongroup";
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { Tooltip, TextControl, Dropdown } = wp.components;

const control = {
    position: [['default', __('Default')], ['left top', __('Left Top')], ['left center', __('Left Center')], ['left bottom', __('Left Bottom')], ['right top', __('Right Top')], ['right center', __('Right Center')], ['right bottom', __('Right Bottom')], ['center top', __('Center Top')], ['center center', __('Center Center')], ['center bottom', __('Center Bottom')]],
    attachment: [['default', __('Default')], ['scroll', __('Scroll')], ['fixed', __('Fixed')]],
    repeat: [['default', __('Default')], ['no-repeat', __('No Repeat')], ['repeat', __('Repeat')], ['repeat-x', __('Repeat X')], ['repeat-y', __('Repeat Y')]],
    size: [['default', __('Default')], ['auto', __('Auto')], ['cover', __('Cover')], ['contain', __('Contain')]],
    parallax: [['none', __('None')], ['fixed', __('Fixed')], ['animated', __('Animated')]]
}

const defaultData = {
    openBg: 0,
    bgType: 'color',
    videoSource: 'local',
    bgDefaultColor: '',
    bgGradient: {},
};

class Background extends Component {

    componentWillMount() {
        const { value } = this.props
        this.props.onChange(Object.assign({}, defaultData, (value || {})));
    }

    setSettings(val, type) {
        const { value, onChange } = this.props
        if ('bgimgParallax' == type) {
            onChange(Object.assign({}, value, { bgimgAttachment: (val == 'fixed' ? val : (val == 'animated') ? 'fixed' : 'scroll'), [type]: val }));
        } else {
            onChange(Object.assign({}, value, { openBg: 1 }, { [type]: val }));
        }
    }

    localImagePicker = () => {
        const { value } = this.props
        return (
            <Media
                panel={true}
                multiple={false}
                type={['image']}
                value={value.bgImage}
                label={__('Background Image')}
                onChange={(val) => this.setSettings(val, 'bgImage')}
            />
        );
    }

    render() {
        const {
            value,
            label,
            externalImage = false,
        } = this.props
        const fieldLabel = label ? label : __('Background');

        return (
            <div className="wprig-field-background wprig-field-color-advanced wprig-field">
                <Color label={fieldLabel + ' ' + __('Color')} value={value.bgDefaultColor} onChange={(val) => this.setSettings(val, 'bgDefaultColor')} />
                <div className="wprig-mb-20 wprig-d-flex wprig-align-center">
                    <div>{fieldLabel + ' ' + __('Type')}</div>
                    <div className="wprig-field-button-list wprig-ml-auto">
                        {
                            this.props.sources.map((data, index) => {
                                return (
                                    <button className={((value.bgType == data && value.openBg) ? 'active' : '') + ' wprig-button'} onClick={() => this.setSettings(data, 'bgType')}>
                                        {data == 'image' &&
                                            <Tooltip text={__('Image')}>
                                                <svg width="18" height="15" viewBox="0 0 18 15" xmlns="http://www.w3.org/2000/svg"><path d="M16.083.263h-14.446c-.798 0-1.445.648-1.445 1.447v11.579c0 .8.646 1.447 1.445 1.447h14.446c.798 0 1.445-.648 1.445-1.447v-11.579c0-.8-.646-1.447-1.445-1.447zm-4.334 2.171c2.389 0 2.386 3.618 0 3.618-2.385 0-2.39-3.618 0-3.618zm-9.39 10.855l4.334-5.789 2.965 3.961 2.091-2.514 3.611 4.342h-13.001z" className="wprig-svg-fill" fill-rule="nonzero" /></svg>
                                            </Tooltip>
                                        }
                                        {data == 'gradient' &&
                                            <Tooltip text={__('Gradient')}>
                                                <svg width="18" height="15" viewBox="0 0 18 15" xmlns="http://www.w3.org/2000/svg"><g transform="translate(.735 .263)" fill="none"><rect className="wprig-svg-stroke" x=".5" y=".5" width="16.072" height="13.474" rx="1" /><path className="wprig-svg-fill" d="M.836.763l15.759 13.158h-15.759z" /></g></svg>
                                            </Tooltip>
                                        }
                                        {data == 'video' &&
                                            <Tooltip text={__('Video')}>
                                                <svg width="18" height="14" viewBox="0 0 18 14" xmlns="http://www.w3.org/2000/svg"><path d="M18 1.679v10.929c0 .281-.131.479-.392.593-.087.033-.171.05-.251.05-.181 0-.331-.064-.452-.191l-4.048-4.048v1.667c0 .797-.283 1.478-.849 2.044-.566.566-1.247.849-2.044.849h-7.071c-.797 0-1.478-.283-2.044-.849-.566-.566-.849-1.247-.849-2.044v-7.071c0-.797.283-1.478.849-2.044.566-.566 1.247-.849 2.044-.849h7.071c.797 0 1.478.283 2.044.849.566.566.849 1.247.849 2.044v1.657l4.048-4.038c.121-.127.271-.191.452-.191.08 0 .164.017.251.05.261.114.392.311.392.593z" className="wprig-svg-fill" fill-rule="nonzero" /></svg>
                                            </Tooltip>
                                        }
                                    </button>
                                )
                            })
                        }
                    </div>
                    {(value && (value.openBg == 1 && value.bgType != 'color')) &&
                        <div className="wprig-ml-10">
                            <Tooltip text={__('Clear')}>
                                <span className="wprig-border-clear" onClick={() => this.setSettings('color', 'bgType')} role="button"><i className="fas fa-undo" /></span>
                            </Tooltip>
                        </div>
                    }
                </div>

                {(value && value.openBg == 1) && (value.bgType === 'image') &&
                    <div className="wprig-background-inner">
                        {
                            externalImage ?
                                <Fragment>
                                    <ButtonGroup
                                        value={typeof value.bgimageSource !== 'undefined' ? value.bgimageSource : 'local'}
                                        label={__('Image Type')}
                                        options={
                                            [
                                                [__('Local'), 'local'],
                                                [__('External'), 'external']
                                            ]
                                        }
                                        onChange={value => this.setSettings(value, 'bgimageSource')}
                                    />
                                    {
                                        (value.bgimageSource === 'local' || typeof value.bgimageSource === 'undefined') ?
                                            this.localImagePicker()
                                            :
                                            <Url label={__('Image Source')} disableAdvanced value={typeof value.externalImageUrl !== 'undefined' ? value.externalImageUrl : {}} onChange={newUrl => this.setSettings(newUrl, 'externalImageUrl')} />
                                    }
                                </Fragment>
                                :
                                this.localImagePicker()
                        }

                        {(value.bgImage && value.bgImage.url) &&
                            <Fragment>
                                {this.props.parallax &&
                                    <div className="wprig-field wprig-d-flex wprig-align-center">
                                        <div>
                                            {__('Parallax')}
                                        </div>
                                        <div className="wprig-field-button-list wprig-ml-auto">
                                            {
                                                control.parallax.map((data, index) => {
                                                    return (
                                                        <Tooltip text={data[1]}>
                                                            <button className={(value.bgimgParallax == data[0] ? 'active' : '') + ' wprig-button'} key={index} onClick={() => this.setSettings(data[0], 'bgimgParallax')}>
                                                                {data[0] == 'none' ?
                                                                    <i className="fas fa-ban" />
                                                                    :
                                                                    data[1]
                                                                }
                                                            </button>
                                                        </Tooltip>
                                                    )
                                                })
                                            }
                                        </div>
                                    </div>
                                }

                                <Dropdown
                                    className="wprig-field"
                                    renderToggle={({ isOpen, onToggle }) => (
                                        <div className="wprig-d-flex wprig-align-center">
                                            <label>{__('Advanced')} {fieldLabel}</label>
                                            <div className="wprig-field-button-list wprig-ml-auto">
                                                <button className={(isOpen == 1 ? 'active' : '') + ' wprig-button wprig-button-rounded'} onClick={onToggle} aria-expanded={isOpen}>
                                                    <i className="fas fa-cog" />
                                                </button>
                                            </div>
                                        </div>
                                    )}
                                    renderContent={() => (
                                        <div style={{ padding: '15px' }}>
                                            <Fragment>
                                                {!this.props.position &&
                                                    <Select label={fieldLabel + ' ' + __('Position')} value={value.bgimgPosition} options={control.position} onChange={(val) => this.setSettings(val, 'bgimgPosition')} />
                                                }
                                                {!this.props.parallax &&
                                                    <Select label={fieldLabel + ' ' + __('Attachment')} value={value.bgimgAttachment} options={control.attachment} onChange={(val) => this.setSettings(val, 'bgimgAttachment')} />
                                                }
                                            </Fragment>
                                            {(!this.props.size || !this.props.repeat) &&
                                                <Fragment>
                                                    {!this.props.repeat &&
                                                        <Select label={fieldLabel + ' ' + __('Repeat')} value={value.bgimgRepeat} options={control.repeat} onChange={(val) => this.setSettings(val, 'bgimgRepeat')} />
                                                    }
                                                    {!this.props.size &&
                                                        <Select label={fieldLabel + ' ' + __('Size')} value={value.bgimgSize} options={control.size} onChange={(val) => this.setSettings(val, 'bgimgSize')} />
                                                    }
                                                </Fragment>
                                            }
                                        </div>
                                    )}
                                />
                            </Fragment>
                        }
                    </div>
                }

                {(value && value.openBg == 1) && (value.bgType === "gradient") &&
                    <div className="wprig-background-inner">
                        <Gradient
                            inline
                            label={__('Gradient')}
                            value={value.bgGradient}
                            onChange={val => this.setSettings(val, 'bgGradient')}
                        />
                    </div>
                }

                {(value && value.openBg == 1) && (value.bgType == 'video') &&
                    <div className="wprig-background-inner">
                        <Select label={__('Video Source')} value={value.videoSource} options={[['local', __('Local')], ['external', __('External')]]} onChange={(val) => this.setSettings(val, 'videoSource')} />
                        {value.videoSource === 'external' ?
                            <TextControl
                                label={__('Video URL')}
                                value={value.bgExternalVideo || ""}
                                onChange={val => this.setSettings(val, 'bgExternalVideo')}
                            />
                            :
                            <Media label={__('Video')} multiple={false} type={['video']} panel={true} value={value.bgVideo} onChange={(val) => this.setSettings(val, 'bgVideo')} />
                        }
                        <Media label={__('Fallback Image (Poster)')} multiple={false} type={['image']} panel={true} value={value.bgVideoFallback} onChange={(val) => this.setSettings(val, 'bgVideoFallback')} />
                    </div>
                }
            </div>
        )
    }
}
export default Background