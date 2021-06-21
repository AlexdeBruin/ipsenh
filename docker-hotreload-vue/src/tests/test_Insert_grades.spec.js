import CourseDashboard from '../components/Teacher/CourseDashboard.vue'
import {shallowMount} from '@vue/test-utils'

const wrapper = shallowMount(CourseDashboard)

describe('courseDashboard', () => {
    test('is a vue instance', () => {
        expect(wrapper.isVueInstance()).toBeTruthy()
    })
    it('contains a v-tab element', () => {
        expect(wrapper.contains('v-tab')).toBeTruthy()
    })
    test('renders correctly', () => {
        expect(wrapper.element).toMatchSnapshot()
    })
    it('tabs is null', () => {
        expect(wrapper.vm.tabs).toBe(null)
    })

})