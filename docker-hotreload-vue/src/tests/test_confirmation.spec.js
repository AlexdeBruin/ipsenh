import Confirmation from '../components/Dialogs/Confirmation.vue'
import {mount} from '@vue/test-utils'

const wrapper = mount(Confirmation)

describe('Confirmation', () => {
    test('is a vue instance', () => {
        expect(wrapper.isVueInstance()).toBeTruthy()
    })
    it('Contains a button', () => {
        expect(wrapper.contains('v-btn')).toBe(true)
    })
    it('it can click the cancle button', () => {
        wrapper.vm.dialog = true
        expect(wrapper.vm.dialog).toBe(true)
        const button = wrapper.find('#cancleButton')
        button.trigger('click')
        expect(wrapper.vm.dialog).toBe(false)
    })
    test('renders correctly', () => {
        expect(wrapper.element).toMatchSnapshot()
    })
})