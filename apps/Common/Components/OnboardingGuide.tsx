import React from 'react'
import ModalSimple from '@hubleto/react-ui/core/ModalSimple';
import TranslatedComponent from '@hubleto/react-ui/core/TranslatedComponent';
import request from '@hubleto/react-ui/core/Request';

/**
 * First-run guide for an app, shown as a single centered card on the app's
 * main page.
 *
 * It opens by itself the first time a user lands on the app and can be
 * reopened from the button it leaves next to the page title. Dismissing it
 * POSTs to the app's `onboarding-seen` endpoint, which records the fact
 * against the user rather than the browser -- see
 * \Hubleto\App\External\TrainingSuite\Common\Onboarding.
 *
 * Steps arrive already translated (the app's controller translates them in its
 * own dictionary); only the chrome around them is translated here.
 */

export interface OnboardingStep {
  icon: string,
  title: string,
  body: string,
}

export interface OnboardingGuideProps {
  uid: string,
  /** Guide slug, must match a key of Hubleto\App\External\TrainingSuite\Common\Onboarding::GUIDES. */
  guide: string,
  /** Endpoint that records the dismissal, e.g. `trainings/api/onboarding-seen`. */
  endpoint: string,
  /** Heading of the card, normally the app name. */
  title: string,
  steps: Array<OnboardingStep>,
  /** Whether this user has already dismissed the guide. */
  seen: boolean,
}

export interface OnboardingGuideState {
  isOpen: boolean,
}

export default class OnboardingGuide extends TranslatedComponent<OnboardingGuideProps, OnboardingGuideState> {
  props: OnboardingGuideProps;
  state: OnboardingGuideState;

  translationContext: string = 'Hubleto\\App\\External\\TrainingSuite\\Common\\Loader';
  translationContextInner: string = 'Components\\OnboardingGuide';

  constructor(props: OnboardingGuideProps) {
    super(props);

    this.state = {
      // A guide with no steps must never open, whatever the seen flag says.
      isOpen: !props.seen && (props.steps ?? []).length > 0,
    };
  }

  getSteps(): Array<OnboardingStep> {
    return this.props.steps ?? [];
  }

  /**
   * Closing is what marks the guide as seen. Someone who closed it on purpose
   * does not want it back on the next page load, and the button next to the
   * title is there when they do.
   */
  close() {
    this.setState({ isOpen: false });

    if (this.props.seen) return;

    request.post(
      this.props.endpoint,
      { guide: this.props.guide },
      {},
      () => { },
      // Failing to remember is not worth interrupting anyone over; the guide
      // simply opens again next time.
      () => { }
    );
  }

  renderStep(step: OnboardingStep, key: number): JSX.Element {
    return <div key={key} className='flex gap-3 items-start'>
      <span className='shrink-0 flex items-center justify-center w-9 h-9 rounded-lg bg-primary/10 text-primary text-base'>
        <i className={step.icon}></i>
      </span>
      <div className='min-w-0'>
        <div className='font-bold leading-snug dark:text-white'>{step.title}</div>
        <div className='mt-1 text-sm leading-relaxed text-gray-600 dark:text-gray-300'>{step.body}</div>
      </div>
    </div>;
  }

  renderCard(): JSX.Element {
    // `.modal-body` pads by 8px only, which is tight for running text.
    return <div className='flex flex-col px-2 pt-1'>
      <p className='text-sm text-gray-500 dark:text-gray-400'>
        {this.translate('A quick tour of what this app does. You can open it again at any time with the Quick guide button.')}
      </p>

      <div className='flex flex-col gap-4 mt-4'>
        {this.getSteps().map((step, i) => this.renderStep(step, i))}
      </div>

      {/* Sticky so the way out stays in reach however long the guide is. */}
      <div className='sticky bottom-0 -mx-2 mt-6 px-2 pt-3 flex justify-end border-t bg-white dark:bg-gray-950'>
        <button type='button' className='btn btn-primary' onClick={() => this.close()}>
          <span className='icon'><i className='fas fa-check'></i></span>
          <span className='text'>{this.translate('Got it')}</span>
        </button>
      </div>
    </div>;
  }

  render(): JSX.Element {
    if (this.getSteps().length === 0) return <></>;

    return <>
      <button
        type='button'
        // nowrap: `.btn .text` allows breaking, so the page header squeezed the
        // label onto two lines.
        className='btn btn-transparent btn-small whitespace-nowrap'
        title={this.translate('Show the quick guide for this app')}
        onClick={() => this.setState({ isOpen: true })}
      >
        <span className='icon'><i className='fas fa-circle-question'></i></span>
        <span className='text'>{this.translate('Quick guide')}</span>
      </button>

      {this.state.isOpen ? <ModalSimple
        uid={this.props.uid + '_modal'}
        type='centered small fit-content'
        isOpen={true}
        showHeader={true}
        title={this.props.title}
        onClose={() => this.close()}
      >
        {this.renderCard()}
      </ModalSimple> : null}
    </>;
  }
}
