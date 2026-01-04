import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

import metadata from '../block.json';
import './editor.scss';

registerBlockType(metadata.name, {
  edit: ({ attributes, setAttributes }) => {
    const blockProps = useBlockProps({ className: 'anxt-cta is-editor' });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Nastavení CTA', 'cta-block-demo')} initialOpen={true}>
            <TextControl
              label={__('Text', 'cta-block-demo')}
              value={attributes.text}
              onChange={(value) => setAttributes({ text: value })}
            />
            <TextControl
              label={__('Text tlačítka', 'cta-block-demo')}
              value={attributes.buttonText}
              onChange={(value) => setAttributes({ buttonText: value })}
            />
            <TextControl
              label={__('URL', 'cta-block-demo')}
              value={attributes.url}
              onChange={(value) => setAttributes({ url: value })}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="anxt-cta__inner">
            <div className="anxt-cta__text">
              {attributes.text || __('(žádný text)', 'cta-block-demo')}
            </div>
            <div className="anxt-cta__actions">
              <span className="anxt-cta__button">
                {attributes.buttonText || __('Tlačítko', 'cta-block-demo')}
              </span>
            </div>
          </div>
        </div>
      </>
    );
  },

  // Server-side render: uloží se jen atributy, HTML vyrenderuje PHP render_callback
  save: () => null
});

